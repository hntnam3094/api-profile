import { PlusIcon, MinusIcon } from "@/Icons";
import {
    Button,
    FileInput,
    Label,
    Radio,
    Select,
    TextInput,
    Textarea,
    Checkbox,
    Datepicker,
} from "flowbite-react";
import { useState, useEffect } from "react";
import Editor from "./QuillEditor/Editor";
import { Controller, useFieldArray } from "react-hook-form";
import { FIELD_TEXT, FIELD_IMAGE, FIELD_SELECT, FIELD_RADIO, FIELD_CHECKBOX, FIELD_DATEPICKER, FIELD_EDITOR, FIELD_TEXTAREA, FIELD_IMAGES } from "@/Constants/Common";
function HasImage({ form, register, watch, setValue, className, isEdit, isDetail }) {
    const [url, setUrl] = useState("");
    const { onChange, ...props } = register(form.name);

    function uploadImage(event) {
        onChange(event);
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                const imageUrl = reader.result;
                setUrl(imageUrl);
            };

            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        setValue(form.name, []);
        setUrl("");
    }

    useEffect(() => {
        const fetchData = async () => {
            const imageUrl = watch(form.name);
            if (typeof imageUrl == 'string') {
                try {
                    const response = await fetch(imageUrl);
                    if (!response.ok) {
                        throw new Error(
                            `Failed to fetch image: ${response.statusText}`
                        );
                    }

                    const blob = await response.blob();
                    const fileRes = new File([blob], "image.jpg", {
                        type: "image/jpeg",
                    });
                    setValue(form.name, [fileRes]);

                    const reader = new FileReader();
                    reader.onloadend = () => {
                        const imageUrl = reader.result;
                        setUrl(imageUrl);
                    };

                    reader.readAsDataURL(fileRes);
                } catch (error) {
                    console.error("Error fetching image:", error);
                }
            }
        };

        fetchData();
    }, [isEdit, watch, form.name, onChange]);

    return (
        <div>
            <FileInput
                onChange={uploadImage}
                {...props}
                className={className}
                disabled={isDetail}
            />
            {url && (
                <div className="relative max-w-[250px]">
                    {!isDetail && (<span
                        onClick={removeImage}
                        className="opacity-90 cursor-pointer absolute bg-white rounded-full p-[5px] m-[3px] right-0"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-x-lg"
                            viewBox="0 0 16 16"
                        >
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                        </svg>
                    </span>)}

                    <img
                        className="max-w-[250px] mt-[10px]"
                        src={url}
                        alt="Uploaded"
                    />
                </div>
            )}
        </div>
    );
}

function HasTextInput({ form, register, className, isDetail }) {
    return (
        <TextInput
            id={form.name}
            defaultValue={form.value}
            {...register(form.name)}
            className={`w-full ${className}`}
            placeholder={form.placeholder}
            disabled={isDetail}
        />
    );
}

function HasSelect({ form, register, className, isDetail }) {
    return (

        <Select id={form.name} {...register(form.name)} className={className} disabled={isDetail}>
            {form.option.map((item, key) => (
                <option key={key} value={item.key}>
                    {item.value}
                </option>
            ))}
        </Select>
    );
}

function GenerationImage({ file, keyField, setValue, isDetail }) {
    const [imageUrl, setImageUrl] = useState("");

    async function getBase64(fileInput) {
        if (typeof fileInput != 'string') {
            const file = fileInput[0];

            if (file) {
                const imageUrlPromise = new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        const result = reader.result;
                        resolve(result);
                    };

                    reader.readAsDataURL(file);
                });

                const result = await imageUrlPromise;
                setImageUrl(result);
            }
        }
    }

    useEffect(() => {
        getBase64(file);
    }, [file]);

    useEffect(() => {
        const fetchData = async () => {
            if (typeof file == 'string') {
                try {
                    const response = await fetch(file);
                    if (!response.ok) {
                        throw new Error(
                            `Failed to fetch image: ${response.statusText}`
                        );
                    }

                    const blob = await response.blob();
                    const fileRes = new File([blob], "image.jpg", {
                        type: "image/jpeg",
                    });
                    setValue(keyField, [fileRes])

                    const reader = new FileReader();
                    reader.onloadend = () => {
                        const imageUrl = reader.result;
                        setImageUrl(imageUrl);
                    };

                    reader.readAsDataURL(fileRes);
                } catch (error) {
                    console.error("Error fetching image:", error);
                }
            }
        };

        fetchData();
    }, [file]);

    function removeImage() {
        setValue(keyField, []);
        setImageUrl("");
    }

    return (
        <div>
            {imageUrl && (
                <div className="relative w-[70%]">
                    {!isDetail && (<span
                        onClick={removeImage}
                        className="opacity-90 cursor-pointer absolute bg-white rounded-full p-[5px] m-[3px] right-0"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-x-lg"
                            viewBox="0 0 16 16"
                        >
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                        </svg>
                    </span>)}

                    <img
                        src={imageUrl}
                        alt="Uploaded"
                    />
                </div>
            )}
        </div>
    );
}

function HasListImage({ form, register, className, watch, control, setValue, isEdit, isDetail }) {
    const { fields, append, remove } = useFieldArray({
        control,
        name: form.name
      });


    function addImage(image) {
        if (image.length > 0) {
            append({
                'image': [],
                'link': '',
                'alt': ''
            })
        } else {
            alert('Please, choose your image before add new')
        }
    }

    function removeImage(key) {
        remove(key)
    }

    useEffect(() => {
        if (fields.length < 1) {
            append({
                'image': [],
                'link': '',
                'alt': ''
            })
        }
    })
    return (
        <div className={className}>
            {fields.map((item, key) => {
                return (
                    <div
                        key={`${form.name}.${key}`}
                        className="w-full flex gap-5 items-center mb-5"
                    >
                        <div className="w-2/4 px-5">
                            <>
                                <div className="mb-2">
                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white ml-2">
                                        File
                                    </label>
                                    <FileInput
                                        {...register(
                                            `${form.name}.${key}.image`
                                        )}
                                        disabled={isDetail}
                                    />
                                </div>
                                <div className="mb-2">
                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white ml-2">
                                        Link
                                    </label>
                                    <TextInput
                                        {...register(
                                            `${form.name}.${key}.link`
                                        )}
                                        disabled={isDetail}
                                    />
                                </div>
                                <div className="mb-2">
                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white ml-2">
                                        Alt
                                    </label>
                                    <TextInput
                                        {...register(
                                            `${form.name}.${key}.alt`
                                        )}
                                        disabled={isDetail}
                                    />
                                </div>
                            </>
                        </div>
                        <div className="w-1/4">
                            <GenerationImage
                                file={watch(`${form.name}.${key}.image`)}
                                keyField={`${form.name}.${key}.image`}
                                setValue={setValue}
                                isDetail={isDetail}
                            />
                        </div>
                        {!isDetail && (
                            <div className="w-1/4 flex gap-10">
                            {key + 1 == fields.length && (
                                <Button
                                    className="bg-green-400"
                                    onClick={() => addImage(watch(`${form.name}.${key}.image`))}
                                >
                                    <PlusIcon />
                                </Button>
                            )}

                            {key + 1 < fields.length && (
                                <Button
                                    className="bg-red-400"
                                    onClick={() => removeImage(key)}
                                >
                                    <MinusIcon />
                                </Button>
                            )}
                        </div>
                        )}


                    </div>
                );
            })}
        </div>
    );
}

function HasCheckbox({ form, control, className }) {
    return (
        <div className={className}>
            {form.option.map((item, key) => (
                <Controller
                    key={key}
                    name={`${form.name}.${key}`}
                    control={control}
                    render={({ field: { value, ...field } }) => (
                        <div className="flex items-center gap-2">
                            <Checkbox
                                id={`${form.name}.${key}`}
                                value={!!value}
                                {...field}
                            />
                            <Label htmlFor={`${form.name}.${key}`}>
                                {item.value}
                            </Label>
                        </div>
                    )}
                />
            ))}
        </div>
    );
}

function HasRadio({ form, register, className }) {
    return (
        <fieldset className={`flex max-w-md flex-col gap-4 ${className}`}>
            {form.option.map((item, key) => (
                <div key={key} className="flex items-center gap-2">
                    <Radio
                        id={`${form.name}.${key}`}
                        value={item.key}
                        {...register(form.name)}
                    />
                    <Label htmlFor={`${form.name}.${key}`}>{item.value}</Label>
                </div>
            ))}
        </fieldset>
    );
}

function HasTextArea({ form, register, className }) {
    return (
        <Textarea
            id={form.name}
            placeholder={form.placeholder}
            rows={form.rows ?? 4}
            {...register(form.name)}
            className={className}
        />
    );
}

function HasEditor({ form, register, control, className }) {
    return (
        <Editor
            form={form}
            register={register}
            control={control}
            Controller={Controller}
            className={className}
        />
    );
}

function HasDatepicker({ form, register, control, className }) {
    return (
        <>
            <Controller
                name={form.name}
                control={control}
                render={({ onChange, value }) => (
                    <Datepicker selected={value} onChange={onChange} />
                )}
            />
        </>
    );
}

function DetectField({
    form,
    register,
    watch,
    control,
    className,
    unregister,
    setValue,
    errors,
    isEdit,
    isDetail
}) {
    function renderForm() {
        switch (form.type) {
            case FIELD_TEXT: {
                return (
                    <HasTextInput
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_IMAGE: {
                return (
                    <HasImage
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        setValue={setValue}
                        className={className}
                        isEdit={isEdit}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_SELECT: {
                return (
                    <HasSelect
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_IMAGES: {
                return (
                    <HasListImage
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        unregister={unregister}
                        isEdit={isEdit}
                        setValue={setValue}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_CHECKBOX: {
                return (
                    <HasCheckbox
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_RADIO: {
                return (
                    <HasRadio
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_TEXTAREA: {
                return (
                    <HasTextArea
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_EDITOR: {
                return (
                    <HasEditor
                        form={form}
                        register={register}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
            case FIELD_DATEPICKER: {
                return (
                    <HasDatepicker
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        className={className}
                        isDetail={isDetail}
                    />
                );
            }
        }
    }

    return (
        <>
            <label
                htmlFor={form.name}
                className="block mb-2 text-sm font-medium text-gray-900 dark:text-white ml-2"
            >
                {form.label}
            </label>
            <div>
                {renderForm()}

                <label className="text-red-400 text-xs">
                    {errors[form.name]}
                </label>
            </div>
        </>
    );
}

export default function FormGeneration({
    form,
    register,
    control,
    watch,
    unregister,
    setValue,
    errors = [],
    isEdit = 0,
    isDetail = 0
}) {
    return (
        <>
            {form.map((item, key) => (
                <div key={key} className="w-full mb-5">
                    <DetectField
                        form={item}
                        register={register}
                        control={control}
                        watch={watch}
                        unregister={unregister}
                        setValue={setValue}
                        errors={errors}
                        isEdit={isEdit}
                        isDetail={isDetail}
                    />
                </div>
            ))}
        </>
    );
}
